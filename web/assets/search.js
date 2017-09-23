$( document ).ready(function() {
    $('form').submit(function(event){
        event.preventDefault();
        $.get(
            '/api/v1/foods/search.json',
            {q: $('#q').val()},
            function(data) {
                let html = '';
                data.forEach(function (food) {
                    html += `
<a href="/food/${food.id}" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">${food.name}</h5>
      <small>${food.foodGroup.name}</small>
    </div>
</a>
`;
                });
                $('#result').html(html);
            },
            'json'
        );
    });
});