<?php
namespace Webimpacto\MiPrimerModulo;

use Symfony\Component\Translation\TranslatorInterface;

class CreateProduct {
    /** @var TranslatorInterface */
    private $translator;

    /** @var string */
    private $customMessage;

    /**
     * @param string $customMessage
     */
    public function __construct(
        TranslatorInterface $translator,
        $customMessage
    ) {
        $this->translator = $translator;
        $this->customMessage = $customMessage;
    }

    /**
     * @return string
     */
    public function getTranslatedCustomMessage() {
        return $this->translator->trans($this->customMessage, [], 'Modules.MiPrimerModulo');
    }
}