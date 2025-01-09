function removeTable() {
  const tableWrapper = document.getElementById("table-wrapper"),
    result = document.getElementById("info_table_result")
  if (confirm("Are you sure you want to delete table?")) {
    tableWrapper.querySelector("table").remove()
    result.value = ""
  }
  checkTableExists()
}

function checkTableExists() {
  const tableWrapper = document.getElementById("table-wrapper")
  tableWrapper.firstChild?.nodeName === "TABLE"
    ? document.getElementById("remove-table").classList.remove("disabled")
    : document.getElementById("remove-table").classList.add("disabled")
}

function switchToHtml() {
  const btn = document.getElementById("info_table_result-html")
  btn.click()
}

window.addEventListener("DOMContentLoaded", () => {
  const newTableForm = document.querySelector(".new_table_form"),
    columns = newTableForm.querySelector('input[name="columns"]'),
    rows = newTableForm.querySelector('input[name="rows"]'),
    tableWrapper = document.getElementById("table-wrapper"),
    result = document.getElementById("info_table_textarea")

  let controls = document.querySelector(".cell-controls")

  setTimeout(() => checkTableExists(), 100)
  setTimeout(() => switchToHtml(), 110)

  function indexTable() {
    const table = tableWrapper.querySelector("table")
    let row_index = 0
    for (let row of table.rows) {
      let cell_index = 0
      for (let cell of row.cells) {
        cell.dataset.trIndex = row_index
        cell.dataset.tdIndex = cell_index
        cell_index++
      }
      row_index++
    }
  }

  function saveTable() {
    const table = tableWrapper.querySelector("table")
    console.log(table.innerHTML)
    result.value = 5555
    console.log(result)

    result.value = `<table>${table.innerHTML}</table>`
  }

  function newTableElement(clicked) {
    const element = clicked.dataset.type
    const position = clicked.dataset.position
    const index =
      clicked.dataset.type === "row"
        ? parseInt(clicked.dataset.trIndex)
        : parseInt(clicked.dataset.tdIndex)

    const table = tableWrapper.querySelector("table")

    if (clicked.dataset.type === "row") {
      const elementIndex = position === "before" ? index : index + 1
      const tdCount = table.rows[0].childElementCount

      const newRow = table.insertRow(elementIndex)
      for (let i = 0; i < tdCount; i++) {
        const newCell = newRow.insertCell()
        newCell.setAttribute("contenteditable", true)
      }
    }

    if (clicked.dataset.type === "column") {
      const elementIndex = position === "before" ? index : index + 1
      const tdCount = table.rows[0].childElementCount

      for (let row of table.rows) {
        const newCell = row.insertCell(elementIndex)
        newCell.setAttribute("contenteditable", true)
      }
    }

    indexTable()
    saveTable()
  }

  function removeTableElement(btn) {
    if (!confirm(`Are you sure you want to delete ${btn.dataset.target}?`))
      return

    const rowIndex = btn.dataset.trIndex,
      columnIndex = btn.dataset.tdIndex
    table = tableWrapper.querySelector("table")

    if (
      (rowIndex && table.rows.length == 1) ||
      (columnIndex && table.rows[0].cells.length == 1)
    ) {
      removeTable()
      return
    }

    if (rowIndex) table.deleteRow(rowIndex)

    if (columnIndex) {
      for (let row of table.rows) {
        row.deleteCell(columnIndex)
      }
    }

    indexTable()
    saveTable()
  }

  function removeControls() {
    controls?.remove()
    tableControls = document.querySelectorAll(".table-controls")
    if (tableControls) tableControls.forEach((item) => item.remove())
  }

  document.addEventListener("click", (e) => {
    if (e.target.matches(".control-button")) newTableElement(e.target)
    if (e.target.matches(".table-controls")) removeTableElement(e.target)
    if (!tableWrapper.contains(e.target)) removeControls()
  })

  if (result.value) {
    tableWrapper.innerHTML = result.value
    const tds = tableWrapper.querySelectorAll("td")
    tds.forEach((td) => td.setAttribute("contenteditable", true))
  }

  const showControls = (input) => {
    if (!input.matches("td")) return

    const rect = input.getBoundingClientRect()
    const scrolledTop = document.documentElement.scrollTop
    const scrolledLeft = document.documentElement.scrollLeft

    removeControls()

    controls = document.createElement("div")
    controls.classList.add("cell-controls")

    controls.style.width = `${rect.width}px`
    controls.style.height = `${rect.height}px`
    controls.style.left = `${scrolledLeft + rect.left}px`
    controls.style.top = `${scrolledTop + rect.top}px`

    const buttons = `
      <span class='control-button top' title='Add new row before' data-position="before" data-type="row" data-td-index="${input.dataset.tdIndex}" data-tr-index="${input.dataset.trIndex}">+</span>
      <span class='control-button right' title='Add new column after' data-position="after" data-type="column" data-td-index="${input.dataset.tdIndex}" data-tr-index="${input.dataset.trIndex}">+</span>
      <span class='control-button bottom' title='Add new row after' data-position="after" data-type="row" data-td-index="${input.dataset.tdIndex}" data-tr-index="${input.dataset.trIndex}">+</span>
      <span class='control-button left' title='Add new column before' data-position="before" data-type="column" data-td-index="${input.dataset.tdIndex}" data-tr-index="${input.dataset.trIndex}">+</span>
    `
    controls.innerHTML = buttons
    document.body.appendChild(controls)

    wrapperRect = tableWrapper.getBoundingClientRect()

    deleteColumn = document.createElement("div")
    deleteColumn.classList.add("table-controls", "delete-column")
    deleteColumn.innerHTML = "-"
    deleteColumn.title = "Delete column"
    deleteColumn.style.left = `${
      scrolledLeft + rect.left + rect.width / 2 - 7
    }px`
    deleteColumn.style.top = `${
      scrolledTop + wrapperRect.top + wrapperRect.height + 10
    }px`
    deleteColumn.dataset.tdIndex = input.dataset.tdIndex
    deleteColumn.dataset.target = "column"

    deleteRow = document.createElement("div")
    deleteRow.classList.add("table-controls", "delete-row")
    deleteRow.innerHTML = "-"
    deleteRow.title = "Delete row"
    deleteRow.style.left = `${
      scrolledLeft + wrapperRect.left + wrapperRect.width + 10
    }px`
    deleteRow.style.top = `${scrolledTop + rect.top + rect.height / 2 - 7}px`
    deleteRow.dataset.trIndex = input.dataset.trIndex
    deleteRow.dataset.target = "row"

    document.body.appendChild(deleteColumn)
    document.body.appendChild(deleteRow)
  }

  const checkInput = (input) => {
    if (!input.value || input.value < 2) {
      input.classList.add("error")
      return false
    } else {
      input.classList.remove("error")
      return true
    }
  }

  const generateTable = (rows, columns) => {
    const table = document.createElement("table")
    for (let i = 0; i < parseInt(rows); i++) {
      const tr = table.insertRow()
      for (let j = 0; j < parseInt(columns); j++) {
        const td = tr.insertCell()
        td.setAttribute("contenteditable", true)
      }
    }

    tableWrapper.innerHTML = ""
    tableWrapper.appendChild(table)

    indexTable()
    saveTable()
    checkTableExists()
  }

  columns.addEventListener("input", (e) => checkInput(e.target))
  rows.addEventListener("input", (e) => checkInput(e.target))

  newTableForm.addEventListener("click", (e) => {
    if (e.target.matches("button")) {
      if (checkInput(columns) && checkInput(rows))
        generateTable(rows.value, columns.value)
    }
  })

  tableWrapper.addEventListener("input", (e) => {
    const table = tableWrapper.getElementsByTagName("table")[0]
    controls.style.height = `${e.target.getBoundingClientRect().height}px`

    const scrolledTop = document.documentElement.scrollTop
    wrapperRect = tableWrapper.getBoundingClientRect()
    const deleteColumn = document.querySelector(".delete-column")
    deleteColumn.style.top = `${
      scrolledTop + wrapperRect.top + wrapperRect.height + 10
    }px`

    result.value = `<table>${table.innerHTML}</table>`
  })

  tableWrapper.addEventListener("click", (e) => {
    showControls(e.target)
  })
})
