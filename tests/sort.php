<!DOCTYPE html>
<html>
<body>

<h1>Сортировка списка по числам</h1>

<p>Нажмите на кнопку, чтобы отсортировать список по числам:</p>
<button onclick="sortList()">Сортировать</button>

<ul id="id01">
  <li>4</li>
  <li>3</li>
  <li>1</li>
  <li>7</li>
  <li>1000</li>
  <li>5234234</li>
  <li>2</li>
  <li>100</li>
</ul>

<script>
function sortList() {
  var list, i, switching, b, shouldSwitch;
  list = document.getElementById("id01");
  switching = true;
  /* Сделайте петлю, которая будет продолжаться до тех пор, пока
  никакого переключения не было сделано: */
  while (switching) {
    // начните с того, что скажите: никакого переключения не происходит:
    switching = false;
    b = list.getElementsByTagName("LI");
    // Loop through all list-items:
    for (i = 0; i < (b.length - 1); i++) {
      // начните с того, что не должно быть никакого переключения:
      shouldSwitch = false;
      /* проверьте, должен ли следующий элемент
      переключение с текущего элемента: */
      
      if (Number(b[i].innerHTML) > Number(b[i + 1].innerHTML)) {
        /* если следующий элемент численно
        ниже текущего элемента, отметьте как переключатель
        и разорвать петлю: */
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /* Если переключатель был отмечен, сделайте переключатель
      и отметьте переключатель как сделано: */
      b[i].parentNode.insertBefore(b[i + 1], b[i]);
      switching = true;
    }
  }
}
</script>

</body>
</html>