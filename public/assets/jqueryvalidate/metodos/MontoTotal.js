
const MontoTotal = ({rendimiento, costo, km_total}) => {
    if (rendimiento === '' || costo === '' || km_total === '') {
        return 0;
    }
  return (
    Math.round(Number((Math.abs((km_total / rendimiento ) * costo) * 100).toPrecision(15))) / 100 * Math.sign((km_total / rendimiento ) * costo)
  )
}

export default MontoTotal;
