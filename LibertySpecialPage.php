<?php
// @codingStandardsIgnoreLine
class LibertySpecialPage extends SpecialPage
{
    public function __construct()
    {
        parent::__construct('Liberty');
    }

    public function execute($par)
    {
        $request = $this->getRequest();
        $output = $this->getOutput();
        $this->setHeaders();

        $param = $request->getText( 'param' );

        $output->setPageTitle(wfMessage('liberty-sp-title')->plain());
        $output->addHTML($this->body());
    }
    
    public function getGroupName()
    {
        return 'maintenance';
    }

    /* Protected Function here */

    protected function body()
    {
        ob_start(); ?>
        <form>
            <?= wfMessage('liberty-sp-colorSetting'); ?> : 
            <input type="text" name="mainColor" value="#4188F1" placeholder="<?= wfMessage('liberty-sp-colorMain'); ?>">
            <input type="text" name="focusColor" value="#71A5F4" placeholder="<?= wfMessage('liberty-sp-colorFocus'); ?>">
            <hr />
            <?= wfMessage('liberty-sp-navSetting'); ?> : 
            <input type="text" name="navArticle" value="MediaWiki:Liberty-Navbar" placeholder="<?= wfMessage('liberty-sp-navArticle'); ?>">
        </form>
        <?php return ob_get_clean();
    }
}
