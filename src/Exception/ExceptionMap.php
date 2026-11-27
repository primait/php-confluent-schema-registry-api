<?php

declare(strict_types=1);

namespace PrimaAssicurazioni\SchemaRegistryApi\Exception;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use function array_key_exists;
use function sprintf;

final class ExceptionMap
{
    public const string UNKNOWN_ERROR_MESSAGE = 'Unknown Error';
    public const string ERROR_CODE_FIELD_NAME = 'error_code';
    public const string ERROR_MESSAGE_FIELD_NAME = 'message';

    private static ?self $instance = null;

    public static function instance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
    }

    /**
     * Maps a RequestException to the internal SchemaRegistryException types.
     *
     * @param GuzzleException $exception
     *
     * @return SchemaRegistryException
     *
     * @throws RuntimeException
     */
    public function __invoke(GuzzleException $exception): SchemaRegistryException
    {
        if (!$exception instanceof RequestException) {
            throw $exception;
        }

        $response = $this->guardAgainstMissingResponse($exception);
        $decodedBody = $this->guardAgainstMissingErrorCode($response);
        $errorCode = $decodedBody[self::ERROR_CODE_FIELD_NAME];
        $errorMessage = $decodedBody[self::ERROR_MESSAGE_FIELD_NAME];

        return $this->mapErrorCodeToException($errorCode, $errorMessage);
    }

    private function guardAgainstMissingResponse(RequestException $exception): ResponseInterface
    {
        $response = $this->extractResponse($exception);

        if (!$response instanceof ResponseInterface) {
            throw new RuntimeException('RequestException has no response to inspect', 0, $exception);
        }

        return $response;
    }

    /**
     * Guzzle 7 exposes getResponse() on every RequestException, Guzzle 8 only on its ResponseException subclass.
     */
    private function extractResponse(object $exception): mixed
    {
        return method_exists($exception, 'getResponse') ? $exception->getResponse() : null;
    }

    /**
     * @param ResponseInterface $response
     * @return array<mixed, mixed>
     */
    private function guardAgainstMissingErrorCode(ResponseInterface $response): array
    {
        try {
            $decodedBody = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);

            if (!is_array($decodedBody) || !array_key_exists(self::ERROR_CODE_FIELD_NAME, $decodedBody)) {
                throw new RuntimeException(
                    sprintf(
                        'Invalid message body received - cannot find "error_code" field in response body "%s"',
                        (string) $response->getBody()
                    )
                );
            }

            return $decodedBody;
        } catch (\Throwable $e) {
            throw new RuntimeException(
                sprintf(
                    'Invalid message body received - cannot find "error_code" field in response body "%s"',
                    (string) $response->getBody()
                ),
                $e->getCode(),
                $e
            );
        }
    }

    private function mapErrorCodeToException(int $errorCode, string $errorMessage): SchemaRegistryException
    {
        return match ($errorCode) {
            IncompatibleAvroSchemaException::errorCode(),
            IncompatibleAvroSchemaException::LEGACY_ERROR_CODE => new IncompatibleAvroSchemaException($errorMessage, $errorCode),
            BackendDataStoreException::errorCode() => new BackendDataStoreException($errorMessage, $errorCode),
            OperationTimedOutException::errorCode() => new OperationTimedOutException($errorMessage, $errorCode),
            MasterProxyException::errorCode() => new MasterProxyException($errorMessage, $errorCode),
            InvalidVersionException::errorCode() => new InvalidVersionException($errorMessage, $errorCode),
            InvalidAvroSchemaException::errorCode() => new InvalidAvroSchemaException($errorMessage, $errorCode),
            SchemaNotFoundException::errorCode() => new SchemaNotFoundException($errorMessage, $errorCode),
            SubjectNotFoundException::errorCode() => new SubjectNotFoundException($errorMessage, $errorCode),
            VersionNotFoundException::errorCode() => new VersionNotFoundException($errorMessage, $errorCode),
            InvalidCompatibilityLevelException::errorCode() => new InvalidCompatibilityLevelException($errorMessage, $errorCode),
            default => throw new RuntimeException(sprintf('Unknown error code "%d"', $errorCode)),
        };
    }
}
