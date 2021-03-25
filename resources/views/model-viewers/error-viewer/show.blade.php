{{ optional($component->getModel()->getException())->getMessage() }}

@dump(optional(request())->server())

@dump($component->getModel()->getException())