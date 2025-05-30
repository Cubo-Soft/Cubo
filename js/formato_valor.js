const formatter = new Intl.NumberFormat('de-DE', {  // europa: coma (,) para decimales, punto (.) para miles
    style: 'decimal',
minimumFractionDigits: 2,
maximumFractionDigits: 2
}); 