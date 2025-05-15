from aiogram.types import InlineKeyboardMarkup, InlineKeyboardButton
from aiogram.utils.keyboard import InlineKeyboardBuilder

def get_main_menu_keyboard() -> InlineKeyboardMarkup:
    """Создает клавиатуру главного меню"""
    keyboard = [
        [
            InlineKeyboardButton(text="📅 Расписание", callback_data="menu_schedule"),
            InlineKeyboardButton(text="📋 Мои записи", callback_data="menu_bookings")
        ],
        [
            InlineKeyboardButton(text="💰 Баланс", callback_data="menu_balance"),
            InlineKeyboardButton(text="📚 Темы консультаций", callback_data="menu_topics")
        ]
    ]
    return InlineKeyboardMarkup(inline_keyboard=keyboard)

def get_back_to_menu_keyboard() -> InlineKeyboardMarkup:
    """Создает клавиатуру с кнопкой возврата в меню"""
    keyboard = [
        [
            InlineKeyboardButton(
                text="◀️ Вернуться в меню",
                callback_data="back_to_menu"
            )
        ]
    ]
    return InlineKeyboardMarkup(inline_keyboard=keyboard)

def get_topics_keyboard():
    """Возвращает клавиатуру с кнопками для выбора тем консультаций по кибербезопасности"""
    keyboard = InlineKeyboardBuilder()
    
    keyboard.button(text="📅 Расписание", callback_data="menu_schedule")
    keyboard.button(text="💰 Баланс", callback_data="menu_balance")
    keyboard.button(text="◀️ Назад в меню", callback_data="back_to_menu")
    
    keyboard.adjust(2, 1)
    return keyboard.as_markup() 