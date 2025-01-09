document.addEventListener('DOMContentLoaded', () => {
  const icons = document.querySelector('.glovelabels'),
        print = document.getElementById('primary-print')

  const printIconWrapper = print.querySelector('.icons')
  const iconsCopy = icons.cloneNode(true)

  if (printIconWrapper && icons) printIconWrapper.appendChild(iconsCopy)

  console.log(icons)
})