var root_inv = "http://localhost:4006/tf2/api/inv";
var root_wep = "http://localhost:4006/tf2/api/wep";
var root_schema = "http://localhost:4006/tf2/api/sch";

$(document).ready(function() {
  //find_inv();
  //find_wep();
  find_sch();
});

var find_inv = function()
{
    console.log('list_inventory');
    $.ajax({
        type: 'GET',
        url: root_inv,
        dataType: "json",
        success: render_inv
    });
};

var find_wep = function()
{
    console.log('list_weapons');
    $.ajax({
        type: 'GET',
        url: root_wep,
        dataType: "json",
        success: render_wep
    });
};

var find_sch = function()
{
    console.log('list_schema');
    $.ajax({
        type: 'GET',
        url: root_schema,
        dataType: "json",
        success: render_schema
    });
};

var render_inv = function(data)
{
    list = data.backpack;

    $.each(list, function(index, backpack)
    {
        $('.results-table').append('<tr><td>'+ backpack.result[0].status +'</td></tr>');
    });

    console.log("END");
};

var render_wep = function(data)
{
    list = data.result.items;

    $.each(list, function(index, items)
    {

        if(items.custom_name != undefined)
        {
          items.custom_name = items.custom_name;
        }
        else
        {
          items.custom_name = "";
        }

        if(items.quality == 6){items.quality = "Unique";}
        else if(items.quality == 15){items.quality = "Decorated";}
        else if(items.quality == 11){items.quality = "Strange";}
        else if(items.quality == 5){items.quality = "Unusual";}
        else if(items.quality == 13){items.quality = "Haunted";}
        else if(items.quality == 1){items.quality = "Genuine";}
        else{items.quality = items.quality;}

        $('.results-weapons').append('<tr><td>'+ items.defindex +'</td><td>'+ items.level +'</td><td>'+ items.quality +'</td><td>'+ items.custom_name +'</td></tr>');
    });

    console.log("END");
};

var render_schema = function(data)
{
    list = data.result.items;

    $.each(list, function(index, items)
    {
        $('.results-schema').append('<div class="col-md-3"><img src="' + items.image_url + '"/><div class="col-xs-12">'+ items.item_name +'</div><div class="col-xs-6">'+ items.defindex +'</div><div class="col-xs-6">'+ items.item_type_name +'</div></div>')
    });

    console.log("END");
};
