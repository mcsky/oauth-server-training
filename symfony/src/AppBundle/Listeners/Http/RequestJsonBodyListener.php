<?php
namespace AppBundle\Listeners\Http;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RequestJsonBodyListener
{
    private $allowedHttpContentMethods = [Request::METHOD_POST, Request::METHOD_PUT, Request::METHOD_PATCH];

    public function onKernelRequest(GetResponseEvent $responseEvent)
    {
        $request = $responseEvent->getRequest();

        if(in_array($request->getMethod(), $this->allowedHttpContentMethods) && false !== strpos($request->headers->get('Content-Type',''), 'application/json')) {
            $dataJson = $request->getContent();
            if('' === $dataJson) {
                $data = [];
            }
            else if(null === $data = @json_decode($dataJson, true)){
                throw new BadRequestHttpException('Malformated JSON');
            }

            $request->request = new ParameterBag($data);
        }
    }
}