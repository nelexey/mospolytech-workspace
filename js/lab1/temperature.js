function convertTemperature(deg, conv_type) {
    if (conv_type === 'toC') {
        return `${Math.round((deg - 32) * 5/9)} C`
    } 
    else if (conv_type === 'toF') {
        return `${Math.round(deg * 9/5 + 32)} F`
    }
    else {
        return `Unsupported convertation type: "${conv_type}"`
    }
}

console.log(convertTemperature(451, 'toC'))