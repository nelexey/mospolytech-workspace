function filterArr(arr, filterFunc) {
    let newArr = []

    for (let i = 0; i < arr.length; i++)
    {
        if (filterFunc(arr[i])) {newArr.push(arr[i])}
    }

    return newArr
}

function customFilter(num) {
    return num % 2 == 0
}

console.log(filterArr([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20], customFilter))