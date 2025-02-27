<?php
/**
 * OutputTest.php
 *
 * @since       2011-05-23
 * @category    Library
 * @package     PdfFont
 * @author      Nicola Asuni <info@tecnick.com>
 * @copyright   2011-2015 Nicola Asuni - Tecnick.com LTD
 * @license     http://www.gnu.org/copyleft/lesser.html GNU-LGPL v3 (see LICENSE.TXT)
 * @link        https://github.com/tecnickcom/tc-lib-pdf-font
 *
 * This file is part of tc-lib-pdf-font software library.
 */

namespace Test;

/**
 * Output Test
 *
 * @since       2011-05-23
 * @category    Library
 * @package     PdfFont
 * @author      Nicola Asuni <info@tecnick.com>
 * @copyright   2011-2015 Nicola Asuni - Tecnick.com LTD
 * @license     http://www.gnu.org/copyleft/lesser.html GNU-LGPL v3 (see LICENSE.TXT)
 * @link        https://github.com/tecnickcom/tc-lib-pdf-font
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class OutputTest extends TestUtil
{
    protected $preserveGlobalState = false;
    protected $runTestInSeparateProcess = true;

    protected function setupTest()
    {
        define('K_PATH_FONTS', dirname(__DIR__).'/target/tmptest/');
        system('rm -rf '.K_PATH_FONTS.' && mkdir -p '.K_PATH_FONTS);
    }

    public function testOutput()
    {
        $this->setupTest();

        $objnum = 1;
        $buffer = new \Com\Tecnick\Pdf\Font\Stack(1);

        new \Com\Tecnick\Pdf\Font\Import(FONT_MIRROR.'pdfa/pfb/PDFASymbol.pfb', null, 'Type1', 'symbol');
        $buffer->add($objnum, 'pdfasymbol');

        new \Com\Tecnick\Pdf\Font\Import(FONT_MIRROR.'core/Helvetica.afm');
        $buffer->add($objnum, 'helvetica');

        new \Com\Tecnick\Pdf\Font\Import(FONT_MIRROR.'core/Helvetica-Bold.afm');
        $buffer->add($objnum, 'helvetica', 'B');

        new \Com\Tecnick\Pdf\Font\Import(FONT_MIRROR.'core/Helvetica-BoldOblique.afm');
        $buffer->add($objnum, 'helveticaBI');

        new \Com\Tecnick\Pdf\Font\Import(FONT_MIRROR.'core/Helvetica-Oblique.afm');
        $buffer->add($objnum, 'helvetica', 'I');

        new \Com\Tecnick\Pdf\Font\Import(FONT_MIRROR.'freefont/FreeSans.ttf');
        $buffer->add($objnum, 'freesans', '');

        new \Com\Tecnick\Pdf\Font\Import(FONT_MIRROR.'freefont/FreeSansBold.ttf');
        $buffer->add($objnum, 'freesans', 'B');

        new \Com\Tecnick\Pdf\Font\Import(FONT_MIRROR.'freefont/FreeSansOblique.ttf');
        $buffer->add($objnum, 'freesans', 'I');

        new \Com\Tecnick\Pdf\Font\Import(FONT_MIRROR.'freefont/FreeSansBoldOblique.ttf');
        $buffer->add($objnum, 'freesans', 'BIUDO', '', true);

        new \Com\Tecnick\Pdf\Font\Import(FONT_MIRROR.'cid0/cid0jp.ttf', null, 'CID0JP');
        $buffer->add($objnum, 'cid0jp');

        $fonts = $buffer->getFonts();
        $this->assertCount(10, $fonts);

        $encrypt = new \Com\Tecnick\Pdf\Encrypt\Encrypt();
        $outObj = new \Com\Tecnick\Pdf\Font\Output($fonts, $objnum, $encrypt);

        $this->assertEquals(37, $outObj->getObjectNumber());

        $this->assertNotEmpty($outObj->getFontsBlock());
    }
}
