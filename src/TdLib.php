<?php

declare(strict_types=1);

namespace AurimasNiekis\FFI;

use FFI;
use InvalidArgumentException;
use JsonException;
use JsonSerializable;

/**
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class TdLib
{
    private const TDLIB_HEADER_FILE = <<<HEADER
void *td_json_client_create();
void td_json_client_send(void *client, const char *request);
const char *td_json_client_receive(void *client, double timeout);
const char *td_json_client_execute(void *client, const char *request);
void td_json_client_destroy(void *client);
HEADER;

    private FFI       $ffi;
    private FFI\CData $client;

    /**
     * @param string|null $libFile An optional file path/name to `libtdjson.so` library
     */
    public function __construct(string $libFile = null, int $logLvl = 0)
    {
        $libFile = $libFile ?? $this->getLibFilename();

        try {
            $this->ffi = FFI::cdef(static::TDLIB_HEADER_FILE, $libFile);
        } catch (FFI\Exception $exception) {
            throw new InvalidArgumentException(sprintf('Failed loading TdLib library "%s"', $libFile));
        }
        $this->ffi->td_set_log_verbosity_level($logLvl);
        $this->client = $this->ffi->td_json_client_create();
    }

    private function getLibFilename(): string
    {
        switch (PHP_OS_FAMILY) {
            case 'Darwin':
                return 'libtdjson.dylib';

            case 'Windows':
                return 'tdjson.dll';

            case 'Linux':
                return 'libtdjson.so';
            default:
                throw new InvalidArgumentException('Please specify tdjson library file');
        }
    }

    public function __destruct()
    {
        $this->ffi->td_json_client_destroy($this->client);
    }

    /**
     * Receives incoming updates and request responses from the TDLib client.
     *
     * @param float $timeout the maximum number of seconds allowed for this function to wait for new data
     *
     * @return array
     *
     * @throws JsonException
     */
    public function receive(float $timeout): ?array
    {
        $response = $this->ffi->td_json_client_receive($this->client, $timeout);

        if (null === $response) {
            return null;
        }

        return json_decode($response, true, JSON_THROW_ON_ERROR);
    }

    /**
     * Sends request to the TDLib client.
     *
     * @param array|JsonSerializable $request
     *
     * @throws JsonException
     */
    public function send($request): void
    {
        $json = json_encode($request, JSON_THROW_ON_ERROR);

        $this->ffi->td_json_client_send($this->client, $json);
    }

    /**
     * Synchronously executes TDLib request.
     * Only a few requests can be executed synchronously.
     *
     * @param array|JsonSerializable $request
     *
     * @return array
     *
     * @throws JsonException
     */
    public function execute($request): ?array
    {
        $json = json_encode($request, JSON_THROW_ON_ERROR);

        $response = $this->ffi->td_json_client_execute($this->client, $json);

        if (null === $response) {
            return null;
        }

        return json_decode($response, true, JSON_THROW_ON_ERROR);
    }
}
