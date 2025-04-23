function toBeCloseTo(num1, num2) {
    return Math.abs(num1 - num2) < Number.EPSILON
}

console.log(toBeCloseTo(0.5, 0.500000000000000000000000001)) 
console.log(toBeCloseTo(1.0, 1.000000001)) 