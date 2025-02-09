import json
import os
from typing import List, Dict
from datetime import datetime

class ValidationError(Exception):
    pass

class FileDatabase:
    def __init__(self, filename: str = "database.json"):
        self.filename = filename
        self._ensure_database_exists()
    
    def _ensure_database_exists(self):
        if not os.path.exists(self.filename):
            with open(self.filename, 'w', encoding='utf-8') as f:
                json.dump([], f)
    
    def _validate_record(self, record: Dict) -> Dict:
        try:
            # Проверяем наличие всех необходимых полей
            required_fields = ['city', 'country', 'population', 'founded_year', 'coordinates']
            if not all(field in record for field in required_fields):
                raise ValidationError("Отсутствуют обязательные поля")

            # Валидация и преобразование данных
            validated = {
                'city': str(record['city']).strip(),
                'country': str(record['country']).strip(),
                'population': int(record['population']),
                'founded_year': int(record['founded_year']),
                'coordinates': str(record['coordinates']).strip()
            }

            # Дополнительные проверки
            if len(validated['city']) < 1:
                raise ValidationError("Название города не может быть пустым")
            
            if len(validated['country']) < 1:
                raise ValidationError("Название страны не может быть пустым")
            
            if validated['population'] <= 0:
                raise ValidationError("Население должно быть положительным числом")
            
            current_year = datetime.now().year
            if validated['founded_year'] > current_year:
                raise ValidationError("Год основания не может быть больше текущего года")
            
            if validated['founded_year'] < -5000:
                raise ValidationError("Год основания не может быть раньше 5000 до н.э.")

            # Простая проверка формата координат (xx.xxxx, yy.yyyy)
            if not all(c in "0123456789., -" for c in validated['coordinates']):
                raise ValidationError("Координаты должны содержать только цифры, точки, запятые и пробелы")

            return validated

        except ValueError as e:
            raise ValidationError(f"Ошибка преобразования типов данных: {str(e)}")
        except Exception as e:
            raise ValidationError(f"Ошибка валидации: {str(e)}")

    def load_data(self) -> List[Dict]:
        with open(self.filename, 'r', encoding='utf-8') as f:
            return json.load(f)
    
    def save_data(self, data: List[Dict]):
        with open(self.filename, 'w', encoding='utf-8') as f:
            json.dump(data, f, indent=2, ensure_ascii=False)
    
    def view_records(self):
        data = self.load_data()
        if not data:
            print("База данных пуста")
            return
        
        for i, record in enumerate(data, 1):
            print(f"\nГород #{i}:")
            print(f"Название: {record['city']}")
            print(f"Страна: {record['country']}")
            print(f"Население: {record['population']:,} человек")
            print(f"Год основания: {record['founded_year']}")
            print(f"Координаты: {record['coordinates']}")
    
    def add_record(self, record: Dict):
        try:
            validated_record = self._validate_record(record)
            data = self.load_data()
            data.append(validated_record)
            self.save_data(data)
            print("Запись успешно добавлена")
        except ValidationError as e:
            print(f"Ошибка валидации: {str(e)}")
    
    def delete_record(self, index: int):
        data = self.load_data()
        if 0 <= index < len(data):
            deleted = data.pop(index)
            self.save_data(data)
            print("Запись успешно удалена")
            return deleted
        print("Неверный индекс записи")
    
    def edit_record(self, index: int, new_data: Dict):
        try:
            validated_record = self._validate_record(new_data)
            data = self.load_data()
            if 0 <= index < len(data):
                data[index] = validated_record
                self.save_data(data)
                print("Запись успешно обновлена")
                return True
            print("Неверный индекс записи")
            return False
        except ValidationError as e:
            print(f"Ошибка валидации: {str(e)}")
            return False 
