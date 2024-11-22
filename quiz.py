def main():
    total = count = 0
    while True:
        user_input = input("Enter an integer or 'done' to finish: ").lower()
        if user_input == "done":
            break
        try:
            total += int(user_input)
            count += 1
        except ValueError:
            print("Invalid input. Please enter an integer.")
    if count:
        return (f"Total: {total} \nCount: {count} \nAverage: {total / count:.2f}")
    else:
        return "You didn't enter any number."
results = main()
print(results)