function fir(length) {
    let symbol
    let string_ = ''

    for (let i=0; i<=length; i++)
    {
        symbol = i%2==0 ? '#' : '*'

        string_ += symbol.repeat(i) +  '\n' 
    }

    return string_ + '||'
}

console.log(fir(10))