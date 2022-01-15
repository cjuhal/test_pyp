<form id="form_search" role="search" method="get" class="search-form mb-5" action="<?php echo home_url().'/category/'.get_category_slug();?>">
	
	<div class="input_search_valakax">
		<input type="text" class="search-field" style="border: 1px solid grey;padding: 12px 10px !important;" placeholder="Buscador" value="<?php echo get_filter_param();?>" name="filter" id="filter" title="Buscador" />
	</div>
	<div style="display: inline-flex;">
	<input alt="Reiniciar Busqueda" title="Reiniciar Busqueda" type="button" class="search-submit button_search_valakax" style="width: auto !important;background-color: grey !important;padding: 15px 20px !important;font-weight: bold;font-size: 20px;" value="x" onclick="document.getElementById('filter').value='';document.getElementById('form_search').submit();">
	<input alt="Buscar" title="Buscar" type="submit" style="width: auto !important;"class="search-submit button_search_valakax" value="Buscar" />
		</div>
</form>