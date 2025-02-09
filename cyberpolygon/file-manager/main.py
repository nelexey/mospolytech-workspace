from database import FileDatabase

def get_record_data():
    print("\nВведите данные о городе:")
    try:
        city = input("Название города: ")
        country = input("Страна: ")
        population = input("Население (число): ")
        founded_year = input("Год основания: ")
        coordinates = input("Координаты (формат: xx.xxxx, yy.yyyy): ")
        
        return {
            "city": city,
            "country": country,
            "population": population,
            "founded_year": founded_year,
            "coordinates": coordinates
        }
    except Exception as e:
        print(f"Ошибка при вводе данных: {str(e)}")
        return None

def main():
    db = FileDatabase()
    
    while True:
        print("\n=== База данных городов ===")
        print("1. Просмотреть все города")
        print("2. Добавить город")
        print("3. Удалить город")
        print("4. Редактировать информацию о городе")
        print("5. Выход")
        
        choice = input("\nВыберите действие (1-5): ")
        
        if choice == "1":
            db.view_records()
        
        elif choice == "2":
            record = get_record_data()
            if record:
                db.add_record(record)
        
        elif choice == "3":
            db.view_records()
            try:
                index = int(input("\nВведите номер города для удаления (1-N): ")) - 1
                db.delete_record(index)
            except ValueError:
                print("Ошибка: введите корректный номер")
        
        elif choice == "4":
            db.view_records()
            try:
                index = int(input("\nВведите номер города для редактирования (1-N): ")) - 1
                new_data = get_record_data()
                if new_data:
                    db.edit_record(index, new_data)
            except ValueError:
                print("Ошибка: введите корректный номер")
        
        elif choice == "5":
            print("До свидания!")
            break
        
        else:
            print("Неверный выбор. Попробуйте снова.")

if __name__ == "__main__":
    main() 