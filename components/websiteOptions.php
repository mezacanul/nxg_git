<section class="collapse mb-4" id="template-customization">
    <div class="row" id="corpTitle" type="button" data-bs-toggle="collapse" data-bs-target="#website-params" aria-expanded="false" aria-controls="website-params">
        <h3 class="ps-0 mt-3 mb-3 ms-3">Template Customization
            <i class="bi bi-arrow-down-square-fill"></i>
        </h3>
    </div>
    
    <form action="#" class="row collapse ms-4 mb-4 mt-4" id="website-params">
        <div class="col website-params-wrapper">
            <input type="hidden" name="demoPath">
            
            <h3 class='mb-3'>
                <i class="bi bi-arrow-right"></i> 
                Taglines
            </h3>
            <div class="row mb-2 tagline">
                <div class="col-4 p-0 me-3 d-flex">
                    <input type="text" class="form-control me-2" placeholder="Main Tagline" id="main-tagline" name="mainTgln">
                    <button class="btn btn-primary" type="button" onclick="shuffleCustomValue('mainTgln')">
                        <i class="bi bi-shuffle"></i>
                    </button>
                </div>
            </div>
    
            <div class="row mb-5 tagline">
                <div class="col-4 p-0 d-flex">
                    <input type="text" class="form-control me-2" placeholder="Secondary Tagline" id="secondary-tagline" name="subTgln">
                    <button class="btn btn-primary" type="button" onclick="shuffleCustomValue('subTgln')">
                        <i class="bi bi-shuffle"></i>
                    </button>
                </div>
            </div>
    
            <h3 class='mb-3'>
                <i class="bi bi-arrow-right"></i> 
                Colors
            </h3>
            <div class="row mb-5" id='colors'>
            </div>
    
    
            <h3 class='mb-3'>
                <i class="bi bi-arrow-right"></i> 
                Images
            </h3>
            <div class="row align-items-baseline" id='images'>
            </div>
    
        </div>

        <div class='p-0 mt-4'>
            <button class="btn btn-primary mb-3 me-1" id="shuffle-all-btn" onclick="shuffleCustomAll()" type="button">Shuffle All</button>
            <button class="btn btn-primary mb-3 me-1" id="update-created-btn" onclick="updateCreated()" type="button">Update Created Website</button>
        </div>
    </form>
</section>