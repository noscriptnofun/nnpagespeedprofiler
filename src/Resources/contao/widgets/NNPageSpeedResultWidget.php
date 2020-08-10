<?php
# @Author: andreasprietzel
# @Date:   1970-01-01T01:00:00+01:00
# @Last modified by:   andreasprietzel
# @Last modified time: 2020-08-04T12:31:02+02:00

class NNPageSpeedResultWidget extends Contao\Widget
{
    /**
     * @var bool
     */
    protected $blnSubmitInput = true;

    /**
     * @var string
     */
    protected $strTemplate = 'be_widget';

    /**
     * @param mixed $varInput
     * @return mixed
     */
    protected function validator($varInput)
    {
        return parent::validator($varInput);
    }

    /**
     * @return string
     */
    public function generate()
    {
		?>

		<div class="NNPageSpeedResultBox">
			<div class="Results">
		<div class="<?=$this->id?>results"></div>

		<script>
			try {
				var jsonString = decodeURIComponent('<?= base64_decode($this->varValue)?>');
				window['<?=$this->id?>'] = JSON.parse(  jsonString.substr(0, jsonString.lastIndexOf('}')+1));

				var resultPage = new ResultHTMLPage('<?=$this->label?>','<?=$this->id?>');
				jQuery('.<?=$this->id?>results').html(resultPage.render());
				resultPage.processAudits(window['<?=$this->id?>'].lighthouseResult.audits);
				resultPage.setScore( window['<?=$this->id?>'].lighthouseResult.categories.performance.score );
			} catch (variable)
			{

			}
		</script>
		</div>
	</div>
		<?php
		if (empty(strlen($this->varValue)))
		{

			return '<h3>'.$this->label.'</h3><br/><br/>'.$GLOBALS['TL_LANG']['tl_NNPageSpeedProfilerWebsite']['noResultFound'];
		}

		return  '';

    }
}

?>
