function childCategoryList(page) {
    $.ajax({
        url: page,
        type: "POST",
        data: {},
        success: function (data) {
            $("#result").html(data);
        }
    });
}