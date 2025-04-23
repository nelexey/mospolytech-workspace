function randomNumber(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min
}

// Массив рандомных значений из изсходного массива
function sampleArray(arr, count) {
    const result = []
    for (let i = 0; i < count; i++) {
        result.push(arr[randomNumber(0, arr.length - 1)])
    }
    return result
}

console.log(sampleArray([1,2,3,4], 2))
console.log(sampleArray([1,2,3,4], 3))