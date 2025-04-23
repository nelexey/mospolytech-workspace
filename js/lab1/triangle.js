function isTriangle(a, b, c) {
    if (!(a + b > c && a + c > b && b + c > a)) { 
        return 'треугольника не существует'}

    const P = a + b + c

    const S = ((P/2) * (P-a) * (P-b) * (P-c))**2

    const PtoS = P/S 

    return `треугольник существует
периметр = ${P}
площадь = ${S}
соотношение = ${PtoS}`;
}

console.log(isTriangle(3, 4, 5))