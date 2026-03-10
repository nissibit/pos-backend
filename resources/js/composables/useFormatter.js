export function useFormatter() {
  const money = (value) => {
    return new Intl.NumberFormat('es-US', {
    //   style: 'currency',
      currency: 'MZN',
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    }).format(Number(value ?? 0));
  };

  const number = (value) => {
    return new Intl.NumberFormat('pt-PT', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
      useGrouping: true
    }).format(Number(value ?? 0));
  };

  return { money, number };
}