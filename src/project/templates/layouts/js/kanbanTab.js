function allowDrop(ev) {
  ev.preventDefault();
}

function drag(ev) {
  ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
  ev.preventDefault();
  $.ajax({
    url: "/drag-and-drop/columnId/taskId",
    date: {},
    async: true,
    data: {},
    success: function () {
      console.log("success");
    },
  });
}
