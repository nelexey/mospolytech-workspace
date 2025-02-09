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