function division(n, x, y) {
    return n % x === 0 && n % y === 0
}

console.log(division(3, 1, 3))   // true
console.log(division(100, 5, 3)) // false