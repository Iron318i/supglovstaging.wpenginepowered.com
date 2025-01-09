window.addEventListener('DOMContentLoaded', () => {
  const modal = document.querySelector('.enquire-form-modal')
  const overlay = document.getElementById('off-canvas-layer')
  const message = modal?.querySelector('.wpcf7-response-output')

  function closeModal() {
    modal.classList.remove('show')
    overlay.style.display = 'none'
    message.innerHTML = ''
    message.style.display = 'none'
  }

  function openModal(e) {
    const id_field = modal.querySelector('input[name="data-id"]')
    const title_field = modal.querySelector('input[name="data-title"]')
    const link_field = modal.querySelector('input[name="data-link"]')

    id_field.value = e.target.dataset.id
    title_field.value = e.target.dataset.title
    link_field.value = e.target.dataset.link

    modal.classList.add('show')
    overlay.style.display = 'block'
  }

  document.addEventListener('click', (e) => {
    if (e.target.matches('.open-enquire-modal')) openModal(e)
    if (
      e.target.matches('.close-enquire-modal') ||
      e.target.matches('.supro-off-canvas-layer')
    )
      closeModal()
  })

  document.addEventListener(
    'wpcf7submit',
    function (event) {
      if (event.detail.status == 'mail_sent') setTimeout(closeModal, 2000)
    },
    false
  )
})
