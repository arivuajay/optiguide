<div class="search-bg"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "> 
        <div class="search-heading">  <i class="fa fa-search"></i> Find an optical Supplier </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 "> 
        <button class="all-suppliers-btn" type="button"><i class="fa fa-group"></i> All Optical Supplier</button>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <select class="selectpicker">
            <option>Name</option>
            <option>Name 1</option>
            <option>Name 2</option>
            <option>Name 3</option>
            <option>Name 4</option>
        </select>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <select class="selectpicker">
            <option>Type</option>
            <option>Type 1</option>
            <option>Type 2</option>
            <option>Type 3</option>
            <option>Type 4</option>
        </select>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <select class="selectpicker">
            <option>Category</option>
            <option>Category1</option>
            <option>Category 2</option>
            <option>Category 3</option>
            <option>Category 4</option>
        </select>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 "> 
        <select class="selectpicker">
            <option>Products & Services </option>
            <option>Products & Services  1</option>
            <option>Products & Services 2</option>
            <option>Products & Services  3</option>
            <option>Products & Services  4</option>
        </select>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2 "> 
        <select class="selectpicker">
            <option>Brand</option>
            <option>Brand 1</option>
            <option>Brand 2</option>
            <option>Type 3</option>
            <option>Brand 4</option>
        </select>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2 "> 
        <button class="find-btn" type="button">Find</button>
    </div>
</div>

<div class="row"> 

    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7"> 
        <div class="welcome-cont"> 
            <h2> welcome Opti-guide.com </h2>
            <p>You are looking for an optical dispensary? Search through the engine and find what you need!</p>
            <p>You are a professionnal in this industry? Use your access codes and visit the secured zone to find more about canadian suppliers, products and brand names, calendar of upcoming events and to read fresh news from the industry through the Opti-News e-mail newsletter.</p>
            <p>Need an access code? Click here to   <a href="#">Register</a></p>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5"> 
        <div class="opti-rep-cont">
            <div class="opti-rep-logo"> 
                <?php echo CHtml::image("{$this->themeUrl}/images/opti-rep-logo.png", 'Logo') ?>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas congue nibh ipsum, rhoncus. Suspendisse eget purus tellus fermentum.</p>
            <p>Need an access code? Click here to   <a href="#">Register</a></p>
        </div>
    </div>

    <?php $this->renderPartial('_latest_news'); ?>
    
    <?php $this->renderPartial('_calender'); ?>

    <?php $this->renderPartial('_did_you_know'); ?>

</div>