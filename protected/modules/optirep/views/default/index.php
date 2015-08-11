<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 landing-left">  
    <h2> Welcome to Opti-rep.com </h2>
    <p>  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed commodo purus nec velit rhoncus, nec luctus dui volutpat. Morbi sed mi posuere, gravida arcu nec, iaculis nunc. Donec malesuada aliquet aliquam. Nam tincidunt massa et orci ultricies, a sodales felis egestas. Duis risus ligula, facilisis id erat ut, interdum tempus purus. Sed pellentesque elementum posuere. Vestibulum sed maximus enim, eleifend tristique dolor. Aenean ultrices pellentesque sapien, in pulvinar ante eleifend ut. Nam malesuada pretium luctus. Curabitur semper metus non quam varius, ac commodo ligula convallis. Integer lacus purus, lacinia eget est eu, finibus congue justo. Sed rutrum lacus maximus, pulvinar nisi sagittis, convallis nulla. Quisque at elit ultrices, mollis urna mattis, egestas ante. </p> <br/>
    <p> Mauris hendrerit quam in arcu pellentesque porttitor. Quisque vestibulum turpis odio, at scelerisque ex rhoncus sagittis. Etiam id nisi sit amet elit vehicula lacinia. Nullam vel aliquet elit. Sed eget neque orci. Sed rhoncus et sem eget iaculis. </p>
</div>

<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 landing-left">
    <?php echo CHtml::image("{$this->themeUrl}/images/site-screen.jpg", 'Site screen', array('width' => 673, 'height' => 434));?>
</div>
<div class="clearfix"> </div>
<div class="col-xs-12 col-sm-8 col-md-6 col-lg-4 col-sm-offset-2 col-md-offset-3 col-lg-offset-4"> 
    <div class="rep-login">
        <h2> Opti-rep Login </h2>
        <input name="" type="text" class="rep-loginfield" value="User Name">
        <input name="" type="text" class="rep-loginfield" value="Password">
        <div class="row"> 
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><a href="#"> Forgot Password?</a></div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> <input name="" type="button" value="Login" class="rep-login-btn"></div>
        </div>
    </div>
    <div class="signup-cont"> 
        <p>  Dont have account ? Signup ! <br/> 
            <?php echo CHtml::link('Register', '/optirep/default/register')?>
        </p>
    </div>
</div>