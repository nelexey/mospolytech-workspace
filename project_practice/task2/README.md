# Telegram Бот для Консультаций по Кибербезопасности в рамках Киберполигона

Telegram бот для управления записью на платные консультации по кибербезопасности с интегрированной системой оплаты через ЮKassa. Проект разработан как дополнение к основному проекту "Киберполигон".

![Архитектура бота](/project_practice/task2/images/architecture.png)

## Исследование предметной области

### Этапы исследования
1. **Анализ предметной области кибербезопасности**
   - Изучение популярных тем консультаций
   - Определение целевой аудитории
   - Анализ конкурентных решений

2. **Исследование потребностей пользователей Киберполигона**
   - Опрос участников киберучений
   - Выявление пробелов в знаниях
   - Определение формата консультаций

3. **Формирование требований к боту**
   - Функциональные требования
   - Нефункциональные требования
   - Интеграция с основным проектом Киберполигон

![Результаты исследования](/project_practice/task2/images/research.png)

## Основные возможности

### Для клиентов
- 🔒 Запись на консультации по различным темам кибербезопасности
- 📅 Просмотр доступных слотов для консультаций с экспертами
- 💳 Пополнение баланса через ЮKassa
- 📋 Управление своими записями (бронирование/отмена)
- 💬 Прямая связь с администратором и экспертами
- 🕒 Уведомления о предстоящих консультациях

### Для администраторов и экспертов
- ➕ Добавление новых слотов для консультаций
- 👥 Просмотр всех забронированных слотов
- 📊 Управление расписанием и темами консультаций
- 💰 Настройка стоимости консультаций по разным темам
- 📈 Аналитика популярности тем и запросов

![Диаграмма процесса записи](/project_practice/task2/images/booking_process.png)

## Команды бота

- `/menu` - Главное меню
- `/balance` - Проверка баланса
- `/schedule` - Просмотр доступных слотов
- `/my_bookings` - Ваши записи на консультации
- `/topics` - Доступные темы консультаций

## Особенности
- Интеграция с экосистемой Киберполигона
- Автоматическая система оплаты через ЮKassa
- Возврат средств при отмене за 24 часа
- Ограничение на количество активных записей
- Уведомления о скором начале консультации
- Рейтинг экспертов и отзывы после консультаций

## Техническое руководство по созданию бота

### Необходимые компоненты
- Python 3.9+
- Aiogram 3.x (Telegram Bot API)
- SQLAlchemy (ORM для работы с базой данных)
- PostgreSQL (система управления базами данных)
- YooKassa API (для обработки платежей)

### Пошаговая инструкция

#### 1. Подготовка окружения
```bash
# Создание виртуального окружения
python -m venv venv

# Активация виртуального окружения
# Для Windows:
venv\Scripts\activate
# Для Linux/Mac:
source venv/bin/activate

# Установка зависимостей
pip install -r requirements.txt
```

#### 2. Настройка базы данных

```python
# Пример кода для инициализации базы данных (bot/database/main.py)
from sqlalchemy import create_engine
from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy.orm import sessionmaker

class Database:
    BASE = declarative_base()
    engine = None
    session = None
    
    @classmethod
    def init(cls, connection_string):
        cls.engine = create_engine(connection_string)
        cls.BASE.metadata.create_all(cls.engine)
        cls.session = sessionmaker(bind=cls.engine)()
```

![Схема базы данных](/project_practice/task2/images/database_schema.png)

#### 3. Создание модели пользователя

```python
# Пример кода модели пользователя (bot/database/models/user.py)
from sqlalchemy import Column, Integer, BigInteger, String, Numeric
from sqlalchemy.orm import relationship
from bot.database.main import Database

class User(Database.BASE):
    __tablename__ = 'users'

    id = Column(Integer, primary_key=True)
    chat_id = Column(BigInteger, unique=True, nullable=False)
    username = Column(String(255), nullable=True)
    balance = Column(Numeric(10, 2), default=0.00, nullable=False)
    currency = Column(String(3), default='RUB', nullable=False)
    
    # Связи
    bookings = relationship("TimeSlot", back_populates="client")
    payments = relationship("Payment", back_populates="user")
```

#### 4. Настройка обработчиков сообщений

```python
# Пример обработчика команды start (bot/handlers/user/commands.py)
from aiogram import Router
from aiogram.types import Message
from aiogram.filters.command import Command
from bot.database.methods.create import create_user

commands_router = Router()

@commands_router.message(Command('start'))
async def start_command(message: Message):
    user = create_user(message.from_user.id, message.from_user.username)
    
    if user is None:
        text = "С возвращением в бот записи на консультации по кибербезопасности! 👋\n\n"
    else:
        text = "👋 Добро пожаловать в бот записи на консультации по кибербезопасности!\n\n"
    
    text += ("Доступные команды:\n"
            "/schedule - посмотреть доступные слоты для записи\n"
            "/my_bookings - мои записи на консультации\n"
            "/topics - темы консультаций")
    
    await message.answer(text)
```

![Структура проекта](/project_practice/task2/images/project_structure.png)

#### 5. Интеграция с платежной системой

```python
# Пример функции создания платежа (bot/services/payment.py)
from yookassa import Payment
from bot.misc.env import settings

async def create_payment(user_id, amount, description):
    payment = Payment.create({
        "amount": {
            "value": str(amount),
            "currency": "RUB"
        },
        "confirmation": {
            "type": "redirect",
            "return_url": settings.PAYMENT_RETURN_URL
        },
        "capture": True,
        "description": description,
        "metadata": {
            "user_id": user_id
        }
    })
    
    return payment
```

### Развертывание проекта

1. Клонирование репозитория:
```bash
git clone https://github.com/username/cyber-consultation-bot.git
cd cyber-consultation-bot
```

2. Настройка переменных окружения:
```
BOT_TOKEN=your_telegram_bot_token
DATABASE_URL=postgresql://username:password@localhost/dbname
PAYMENT_API_KEY=your_yookassa_api_key
PAYMENT_SHOP_ID=your_yookassa_shop_id
```

3. Запуск бота:
```bash
python run.py
```

![Диаграмма развертывания](/project_practice/task2/images/deployment.png)

## Интеграция с Киберполигоном

Бот для записи на консультации интегрируется с основным проектом Киберполигон следующими способами:

1. Совместная аутентификация пользователей
2. Общая база знаний и материалов
3. Уведомления о предстоящих киберучениях
4. Подбор консультаций по результатам тренировок на Киберполигоне
5. Обмен статистическими данными для улучшения качества услуг

## Будущие улучшения

- Внедрение ИИ для автоматического подбора консультаций
- Групповые консультации со скидкой
- Интеграция с календарями (Google Calendar, Apple Calendar)
- Мобильное приложение для более удобного управления консультациями
- Расширенная аналитика для администраторов и экспертов

## Лицензия

MIT
