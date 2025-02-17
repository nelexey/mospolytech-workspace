class Transport:
    def __init__(self, max_speed: int, horse_power: int):
        self.max_speed = max_speed
        self.horse_power = horse_power


class Car(Transport):
    def __init__(self, max_speed: int, horse_power: int, mass: int, acceleration: int):
        super().__init__(max_speed, horse_power)
        self.mass = mass
        self.acceleration = acceleration


    def show_info(self):
        print(f'Максимальная скорость: {self.max_speed} км/ч')
        print(f'Мощность: {self.horse_power} л.с.')
        print(f'Масса: {self.mass} кг')
        print(f'Ускорение: {self.acceleration} м/с^2')



car1 = Car(max_speed=220, horse_power=150, mass=1200, acceleration=8)
car2 = Car(max_speed=240, horse_power=200, mass=1300, acceleration=6)

car1.show_info()
car2.show_info()

    
# run

# Максимальная скорость: 220 км/ч
# Мощность: 150 л.с.
# Масса: 1200 кг
# Ускорение: 8 м/с^2
# Максимальная скорость: 240 км/ч
# Мощность: 200 л.с.
# Масса: 1300 кг
# Ускорение: 6 м/с^2
