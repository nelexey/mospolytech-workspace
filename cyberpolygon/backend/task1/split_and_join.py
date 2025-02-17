def main(s: str) -> str:
    return s.replace(' ', '-')


if __name__ == '__main__':
    s = input('>>> ')

    r = main(s)

    print(r)

# run

# >>> Привет, как дела
# Привет,-как-дела