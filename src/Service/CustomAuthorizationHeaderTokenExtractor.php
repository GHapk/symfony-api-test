<?php
declare(strict_types=1);
namespace App\Service;

use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * At the moment the prefix is eliminated from header so the user can't login via token.
 * This class is a workaround with a little bit of validation. this should not be used in production.
 * Therefor contact a server administrator to fix the issue with the header
 */
class CustomAuthorizationHeaderTokenExtractor implements TokenExtractorInterface {
    /**
     * @var string
     */
    protected ?string $prefix;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @param string|null $prefix
     * @param string      $name
     */
    public function __construct(string $prefix, string $name)
    {
        $this->prefix = $prefix;
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function extract(Request $request)
    {
        if (!$request->headers->has($this->name)) {

            return false;
        }

        $authorizationHeader = $request->headers->get($this->name);

        if (empty($this->prefix)) {
            return $authorizationHeader;
        }
        $headerParts = explode(' ', (string) $authorizationHeader);
        if (count($headerParts) === 1) {
            $parts = explode('.', $authorizationHeader);
            if (count($parts) === 3) {
                return $authorizationHeader;
            }
        }

        if (!(2 === count($headerParts) && 0 === strcasecmp($headerParts[0], $this->prefix))) {
            return false;
        }

        return $headerParts[1];
    }
}
