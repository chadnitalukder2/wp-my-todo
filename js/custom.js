console.log('hello js file');

jQuery
  .post(wp_todo_plugin.ajax_url, {
    nonce: wp_todo_plugin.nonce,
    action: "wp_todo_abc",
    name: "Puja",
    cars: ["Audi", "BMW"],
    postID: 123,
  })
  .then((res) => {
    console.log(res);
  })
  .catch((error) => {
    console.log(error);
  });
//==========================================================
jQuery
  .post(wp_todo_plugin.ajax_url, {
      action: "wp_todo_abc_again",
      name: ['apple', 'orange', 'mango']
  })
  .then((res) => {
    console.log(res);
  })
  .catch((error) => {
    console.log(error);
  });


