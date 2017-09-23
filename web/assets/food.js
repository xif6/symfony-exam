$( document ).ready(function() {
    $.get(
        `/api/v1/foods/${food_id}.json`,
        {q: $('#q').val()},
        function(food) {
            let html = '';
            food.nutrientsFood.forEach(function (nutrientsFood) {
                html += `
<span class="list-group-item list-group-item-action flex-column align-items-start">
  <div class="d-flex w-100 justify-content-between">
    <h5 class="mb-1">${nutrientsFood.nutrient.name}</h5>
    <small>${nutrientsFood.value}</small>
  </div>
</span>`;
            });
            $('#result').html(html);
        },
        'json'
    );
});