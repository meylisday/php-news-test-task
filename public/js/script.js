$(document).ready(function () {
  const createForm = $('#create-form');
  const editForm = $('#edit-form');
  const editIdInput = $('#edit-id');
  const editTitleInput = $('#edit-title');
  const editDescriptionInput = $('#edit-description');
  const updateButton = $('#update-button');

  createForm.submit(function (event) {
    event.preventDefault();
    const title = $('#title').val();
    const description = $('#description').val();

    $.ajax({
      type: 'POST',
      url: '/news/create',
      dataType: 'json',
      data: {title: title, description: description},
      success: function (response) {
        if (response.status === 'success') {
          $('.success').text(response.message).show();

          const newsList = $('.news-list ul');
          const newNewsItem = `
            <li class="news-item" data-id="${response.news.id}">
              <div>
                  <span class="news-title">${response.news.title}</span>
                  <span class="news-description">${response.news.description}</span>
              </div>
              <span>
                  <a href="#" class="icon edit-btn" title="Edit News" data-id="${response.news.id}"
                     data-title="${response.news.title}" data-description="${response.news.description}">
                      <img src="../../public/images/pencil.svg" width="12" height="12" alt="Edit Icon">
                  </a>
                  <a href="/news/delete/${response.news.id}" class="icon delete-btn" title="Delete News">
                      <img src="../../public/images/close.svg" width="12" height="12" alt="Delete Icon">
                  </a>
              </span>
            </li>`;
          newsList.append(newNewsItem);
          $('#title').val('');
          $('#description').val('');

        } else {
          $('.error').text(response.message).show();
        }
      },
      error: function () {
        $('.error').text('An error occurred.').show();
      }
    });
  });

  $('#login-form').submit(function (event) {
    event.preventDefault();

    const username = $('#username').val();
    const password = $('#password').val();

    $.ajax({
      type: 'POST',
      url: 'login',
      data: {username: username, password: password},
      dataType: 'json',
      success: function (response) {
        if (response.status === 'error') {
          $('#login-error').text(response.message).show();
        } else if (response.status === 'success') {
          window.location.href = '/news';
        }
      },
      error: function () {
        alert('An error occurred.');
      }
    });
  });

  $(document).on('click', '.edit-btn', function () {
    const id = $(this).data('id');
    const title = $(this).data('title');
    const description = $(this).data('description');

    editIdInput.val(id);
    editTitleInput.val(title);
    editDescriptionInput.val(description);

    createForm.hide();
    editForm.show();
  });

  function updateNews() {
    const id = editIdInput.val();
    const title = editTitleInput.val();
    const description = editDescriptionInput.val();

    $.ajax({
      type: 'POST',
      url: '/news/update/' + id,
      dataType: 'json',
      data: {_method: 'PUT', title: title, description: description},
      success: function (response) {
        if (response.status === 'success') {
          $('.success').text(response.message).show();
          const newsId = response.news.id;
          const newsTitle = response.news.title;
          const newsDescription = response.news.description;
          const newsItem = $(`li[data-id="${newsId}"]`);
          newsItem.find('.news-title').text(newsTitle);
          newsItem.find('.news-description').text(newsDescription);

          $('#edit-title').val('');
          $('#edit-description').val('');

          $('#edit-form').hide();
          $('#create-form').show();

        } else {
          $('.error').text(response.message).show();
        }
      },
      error: function () {
        $('.error').text('An error occurred.').show();
      }
    });
  }

  $('#close-edit-form').click(function (event) {
    editForm.hide();
    createForm.show();
  })

  updateButton.click(function (event) {
    event.preventDefault();
    updateNews();
  });

  $(document).on('click', '.delete-btn', function (event) {
    event.preventDefault();
    const deleteUrl = $(this).attr('href');
    const newsItem = $(this).closest('li');

    $.ajax({
      type: 'DELETE',
      url: deleteUrl,
      dataType: 'json',
      success: function (response) {
        if (response.status === 'success') {
          $('.success').text(response.message).show();
          newsItem.remove();
        } else {
          $('.error').text(response.message).show();
        }
      },
      error: function () {
        $('.error').text('An error occurred').show();
      }
    });
  });

});
