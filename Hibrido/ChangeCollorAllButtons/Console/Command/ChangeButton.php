<?php

namespace Hibrido\ChangeCollorAllButtons\Console\Command;

use Codeception\Lib\Di;
use Laminas\Session\Validator\Id;
use Magento\Setup\Module\Di\Compiler\Log\Writer\Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;



/**
 * Class SomeCommand
 */
class ChangeButton extends Command
{
    const hexadecimalColor = 'name';
    const idStore = 'idStore';

    protected $_storeManager;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
    ) {
        $this->_storeManager = $storeManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('color:change');
        $this->setDescription('changes the color of all buttons');
        $this->addArgument(
            self::hexadecimalColor,
            InputArgument::REQUIRED,
            'color hexadecimal'
        );
        $this->addArgument(
            self::idStore,
            InputArgument::REQUIRED,
            'id store view'
        );

        parent::configure();
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null|int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $returnHexadecimal = $this->checkHexadecimalValue($input->getArgument(self::hexadecimalColor));

        $returnViewID = $this->checkIdStore($input->getArgument(self::idStore));


        if ($returnHexadecimal == 'false') {

            $output->writeln(
                '<error> color not valid !</error>'
            );
        } else if ($returnViewID == 'false') {
            $output->writeln(
                '<error> id not valid !</error>'
            );
        } else {

            $this->editStyleButton($input->getArgument(self::hexadecimalColor), $input->getArgument(self::idStore));

            $output->writeln('<info>Sucess!</info>');
        }

        return 0;
    }


    //adicona ou edita a cor hexadecimal.
    protected function editStyleButton($valueHexadecimal,  $storeID)
    {


        $classStoreView = ".store-view-" . $storeID;

        $fileStylePath =  "app/code/Hibrido/ChangeCollorAllButtons/view/frontend/web/css/change-buttons.css";



        $fileStyle = file_get_contents($fileStylePath);


        //strpos retorna falso, quando o valor não é encontrado, e retorna a posição quando o valor existe
        //por isso foi usado o str, porque só preciso verificar se existe um valor ativo ou não. 
        //para poder criar um novo, ou editar um atual a partir disso.
        if (strpos($fileStyle, $classStoreView) !== false) {


            $replaceString = '/\.store-view-' . $storeID . '[^{]*{[^}]*}/';

            $editClassStoreView = ".store-view-" . $storeID . " button { background-color: #" . $valueHexadecimal . " !important; }";

            $textReplace = preg_replace($replaceString, $editClassStoreView, $fileStyle);

            file_put_contents($fileStylePath, $textReplace);
        } else {

            $fileStyle = $fileStyle . "\n .store-view-" . $storeID . " button { background-color: #" . $valueHexadecimal . " !important; }";

            file_put_contents($fileStylePath, $fileStyle);
        }
    }


    //Verifica se a cor hexadecimal é valida ou não.
    protected function checkHexadecimalValue($valueHexadecimal)
    {

        $valueHexadecimal = '#' . $valueHexadecimal;

        $padrao = '/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/';

        if (preg_match($padrao, $valueHexadecimal)) {
            return 'true';
        } else {
            return 'false';
        }
    }



    //verifica se o id da loja é valido ou não.
    protected function checkIdStore($id)
    {

        try {

            if ($this->_storeManager->getStore($id)) {
                return 'true';
            }
        } catch (\Exception $e) {
            return 'false';
        }
    }
}
