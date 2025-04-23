function countSandwiches(ingredients) {
    return Math.min(
        Math.floor(ingredients.bread / 2),
        ingredients.cheese
    )
}

console.log(countSandwiches({bread: 5, cheese: 6}))
console.log(countSandwiches({bread: 10, cheese: 1}))
console.log(countSandwiches({bread: 1, cheese: 3}))