


def main(students: list[tuple[str, int]]) -> tuple[str, int]:
    scores = []

    for _, score in students:
        scores.append(score)

    second_highest_score = sorted(set(scores))[-2]

    students_with_second_highest_score = []

    for student, score in students:
        if score == second_highest_score:
            students_with_second_highest_score.append(student)

    students_with_second_highest_score.sort()

    return students_with_second_highest_score[0], second_highest_score


if __name__ == '__main__':
    students = [['Аня', 90], ['Борис', 92], ['Ваня', 85], ['Дима', 90], ['Ева', 92]]

    r = main(students)

    print(r[0], r[1])


# run

# Аня 90