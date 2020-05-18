<?php
namespace mitienda\miprimermodulo\src;

use Symfony\Component\Translation\TranslatorInterface;

class createProduct {
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
        return $this->translator->trans($this->customMessage, [], 'modules.miprimermodulo');
    }
}