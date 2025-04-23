function fizzBuzz(num) {
    for (let i = 0; i <= num; i++) {
        if (i % 5 === 0) {
            console.log(`${i} fizz buzz`)
        } else if (i % 2 === 0) {
            console.log(`${i} buzz`)
        } else {
            console.log(`${i} fizz`)
        }
    }
}

fizzBuzz(15)