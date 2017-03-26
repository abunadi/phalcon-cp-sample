{% include "layouts/form_box_header" with ['box_title': 'Add New Store', 'expanded_form': '1'] %}
{{ content() }}
<!-- form start -->
{{ form('items/' ~ form_action, 'role': 'form', 'enctype': 'multipart/form-data') }}
    {% if data['id'] is numeric %}
        <input type="hidden" name="id" value="{{ data['id'] }}" />
    {% endif %}
    <div class="box-body">
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="name" placeholder="Enter item name" value="{{ data['name'] }}">
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea rows="5" class="form-control" name="description">{{ data['description'] }}</textarea>
        </div>
        {% if categories is defined %}
            <div class="form-group">
                <label>Category/ies</label>
                <!--<input type="hidden" name="old_categories" value="{{ data['categories_ids'] }}" />-->
                <select name="categories[]" class="form-control" style="height:250px" multiple>
                    {% for category in categories %}
                        <optgroup label="{{ category.name }}">
                        {% for sub_category in sub_categories %}
                            {% if sub_category.parent_id == category.id %}
                                <option {% if sub_category.selected == 1 %}selected="select"{% endif %}value="{{ category.id }},{{ sub_category.id }}">{{ sub_category.name }}</option>
                            {% endif %}
                        {% endfor %}
                        </optgroup>
                   {% endfor %}
                </select>
            </div>
        {% endif %}
        </div>
        <div class="form-group" id="item_image_group">
            <label>Image</label>
            {% if data['media']['images'][0] %}
                <div class="form-group" id="item_image_div">
                    <img src="{{ data['media']['path']  }}{{ data['media']['images'][0] }}" alt="{{ data['media']['images'][0] }}" class="img-rounded" />
                </div>
                <input type="hidden" name="item_image_del" id="item_image_del" value="" />
                <a class="btn btn-danger" id="item_image_del_btn" href="javascript:itemDeleteImage('{{ data['media']['images'][0] }}')" role="button">Delete</a>
            {% else %}
                <input name="item_image" type="file" />
            {% endif %}
        </div>

        <div class="form-group">
            <label>Tags</label>
            <div id="tags"></div>
            <input type="hidden" name="tagslist" id="tagslist" value="{{ data['tagslist'][0] }}" />
        </div>
    </div><!-- /.box-body -->
    <div class="box-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
{% include "layouts/form_box_footer.volt" %}

<script>
	$(function(){
		$("#tags").tags({
            suggestions: [{{ tags }}],
            tagData: [{{ data['tagslist'][1] }}],
			promptText: "Click here to add new tags",
            suggestOnClick: true,
			afterAddingTag: function(tags){$("#tagslist").val($("#tags").tags().tagData) },
			afterDeletingTag: function(tags){$("#tagslist").val($("#tags").tags().tagData) }
        });
	});
</script>
