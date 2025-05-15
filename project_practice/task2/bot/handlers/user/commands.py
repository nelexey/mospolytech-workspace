from aiogram import Router
from aiogram.types import Message
from aiogram.filters.command import Command
from bot.database.methods.create import create_user

commands_router = Router()

@commands_router.message(Command('start'))
async def start_command(message: Message):

    user = create_user(message.from_user.id, message.from_user.username)
    
    if user is None:
        text = "С возвращением в бот записи на консультации по кибербезопасности! 🔐\n\n"
    else:
        text = "🔐 Добро пожаловать в бот записи на консультации по кибербезопасности в рамках проекта КиберПолигон!\n\n"
    
    text += ("Доступные команды:\n"
            "/schedule - посмотреть доступные слоты для записи\n"
            "/my_bookings - мои записи на консультации\n"
            "/topics - доступные темы консультаций")
    
    await message.answer(text)