import json
import os
from typing import List, Dict

class FileDatabase:
    def __init__(self, filename: str = "database.json"):
        self.filename = filename
        self._ensure_database_exists()
    
    def _ensure_database_exists(self):
        if not os.path.exists(self.filename):
            with open(self.filename, 'w', encoding='utf-8') as f:
                json.dump([], f)
    
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
            for key, value in record.items():
                print(f"{key}: {value}")
    
    def add_record(self, record: Dict):
        data = self.load_data()
        data.append(record)
        self.save_data(data)
        print("Запись успешно добавлена")
    
    def delete_record(self, index: int):
        data = self.load_data()
        if 0 <= index < len(data):
            deleted = data.pop(index)
            self.save_data(data)
            print("Запись успешно удалена")
            return deleted
        print("Неверный индекс записи")
    
    def edit_record(self, index: int, new_data: Dict):
        data = self.load_data()
        if 0 <= index < len(data):
            data[index].update(new_data)
            self.save_data(data)
            print("Запись успешно обновлена")
            return True
        print("Неверный индекс записи")
        return False