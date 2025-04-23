function randomNumber(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min
}

console.log(randomNumber(0, 10))
console.log(randomNumber(-10, 10))

