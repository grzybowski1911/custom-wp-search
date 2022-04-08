<?php
$industries = get_terms( array(
    'taxonomy'          => 'experts_industries',
    'hide_empty'        => false,
) );
if(!empty($industries )) {
    $industry_options .= '<option value="">-- Expert Industries --</option>';
    foreach($industries  as $industry) {
        $industry_options .= '<option value="'.$industry->term_id.'">'.$industry->name.'</option>';
    }
} else {
    $industry .= 'Nothing here';
}
?>


<form method="get" action="<?php echo get_post_type_archive_link('experts'); ?>" role="search">
  <div class="form-group">
    <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Search by name or keyword" aria-label="Search by name or keyword">
    <label for="keyword">Search By Keyword or Name</label>
  </div>
  <div class="form-group">
    <input type="text" class="form-control" id="speciality" name="speciality" placeholder="Search by speciality" aria-label="Search by speciality">
    <label for="speciality">Search By Speciality</label>
  </div>
  <div class="form-group">
    <input type="text" class="form-control" id="industry_select" name="industry_select" placeholder="Search by industry" aria-label="Search by industry">
    <label for="industry_select">Select Industry</label>
  </div>
  <div class="form-group">
    <input type="text" class="form-control" id="location_select" name="location_select" placeholder="Search by location" aria-label="Search by location (state)">
    <label for="location_select">Select Location</label>
  </div>
  <!--<div class="form-group">
        <select class="form-select" id="industry_select" name="industry_select" aria-label="Select Industry">
            <?php //echo $industry_options; ?>
        </select>
        <label for="industry_select">Select Industry</label>
  </div>-->
  <button type="submit" class="btn btn-outline-primary btn-lg">Start Search</button>
</form>