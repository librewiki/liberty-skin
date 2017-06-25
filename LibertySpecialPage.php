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
        <h1 style="text-align: center;">MY AWESOME PAGE</h1>
        <?php return ob_get_clean();
    }
}
