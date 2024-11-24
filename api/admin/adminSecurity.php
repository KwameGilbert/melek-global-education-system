<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../../config/database.php';

try {
    // Get admin ID from session
    session_start();
    $adminId = $_SESSION['admin_id'] ?? null;
    if (!$adminId) {
        throw new Exception('Admin not logged in');
    }

    // Get JSON data
    $data = json_decode(file_get_contents("php://input"), true);
    if (empty($data)) {
        throw new Exception('No data provided');
    }

    $db = new Database();
    $conn = $db->getConnection();
    $conn->beginTransaction();

    // Determine action type
    $action = $data['action'] ?? '';

    switch ($action) {
        case 'updatePassword':
            // Validate inputs
            if (!isset($data['currentPassword'], $data['newPassword'], $data['confirmPassword'])) {
                throw new Exception('Missing required fields');
            }

            if ($data['newPassword'] !== $data['confirmPassword']) {
                throw new Exception('New passwords do not match');
            }

            // Validate password strength
            if (strlen($data['newPassword']) < 8) {
                throw new Exception('Password must be at least 8 characters long');
            }

            if (!preg_match('/[A-Z]/', $data['newPassword']) || 
                !preg_match('/[0-9]/', $data['newPassword']) || 
                !preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $data['newPassword'])) {
                throw new Exception('Password must contain at least one uppercase letter, one number, and one special character');
            }

            // Verify current password
            $stmt = $conn->prepare("SELECT password FROM admin_users WHERE admin_id = ?");
            $stmt->execute([$adminId]);
            $currentHash = $stmt->fetchColumn();

            if (!password_verify($data['currentPassword'], $currentHash)) {
                throw new Exception('Current password is incorrect');
            }

            // Update password
            $newHash = password_hash($data['newPassword'], PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE admin_users SET password = ? WHERE admin_id = ?");
            
            if (!$stmt->execute([$newHash, $adminId])) {
                throw new Exception('Failed to update password');
            }

            $message = 'Password updated successfully';
            break;

        case 'toggle2FA':
            $enabled = $data['enabled'] ?? false;
            
            // Update 2FA status
            $stmt = $conn->prepare("UPDATE admin_users SET two_factor_enabled = ? WHERE admin_id = ?");
            
            if (!$stmt->execute([$enabled ? 1 : 0, $adminId])) {
                throw new Exception('Failed to update 2FA status');
            }

            $message = '2FA ' . ($enabled ? 'enabled' : 'disabled') . ' successfully';
            break;

        case 'get2FAStatus':
            $stmt = $conn->prepare("SELECT two_factor_enabled FROM admin_users WHERE admin_id = ?");
            $stmt->execute([$adminId]);
            $enabled = (bool)$stmt->fetchColumn();

            echo json_encode([
                'status' => true,
                'data' => ['enabled' => $enabled]
            ]);
            return;

        default:
            throw new Exception('Invalid action specified');
    }

    $conn->commit();
    echo json_encode([
        'status' => true,
        'message' => $message
    ]);

} catch (Exception $e) {
    if (isset($conn) && $conn->inTransaction()) {
        $conn->rollBack();
    }

    http_response_code(400);
    echo json_encode([
        'status' => false,
        'message' => $e->getMessage()
    ]);
}
