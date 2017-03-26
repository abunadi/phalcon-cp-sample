{% include "layouts/form_box_header" with ['box_title': 'Add New Category'] %}
{{ content() }}
<!-- form start -->
{{ form('categories/' ~ form_action, 'role': 'form') }}
	{% if data['id'] is numeric %}
        <input type="hidden" name="id" value="{{ data['id'] }}" />
    {% endif %}
	<div class="box-body">	
		<div class="form-group">
            <label>Parent Category</label>
            <select name="parent_id" class="form-control">
                <option value="">Select the Parent Category</option>
                {% for category in parent_categories %}
                    <option {% if data['parent_id'] is numeric and data['parent_id'] == category.id %}selected="select"{% endif %}value="{{ category.id }}">{{ category.name }}</option>
                {% endfor  %}
            </select>
        </div>
		<div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="name" placeholder="Enter category name" value="{{ data['name'] }}">
        </div>
		<div class="form-group">
            <label>Description</label>
			<textarea rows="5" class="form-control" name="description">{{ data['description'] }}</textarea>
        </div>
	</div><!-- /.box-body -->
	<div class="box-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
{% include "layouts/form_box_footer.volt" %}
