<?php

namespace Puru\GraphMailer\Graph;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\TextPart;
use Symfony\Component\Mime\Part\Multipart\MultipartPart;

class GraphMimeMapper
{
    public function map(Email $email): array
    {
        $bodyData = $this->extractBody($email->getBody());

        return [
            'subject' => $email->getSubject(),
            'body' => [
                'contentType' => $bodyData['contentType'],
                'content' => $bodyData['content'],
            ],
            'toRecipients'  => $this->addresses($email->getTo()),
            'ccRecipients'  => $this->addresses($email->getCc()),
            'bccRecipients' => $this->addresses($email->getBcc()),
            'replyTo'       => $this->addresses($email->getReplyTo()),
            'attachments'   => $this->attachments($email),
            'internetMessageHeaders' => $this->headers($email),
        ];
    }

    /**
     * Extract body safely from any multipart structure.
     */
    protected function extractBody($part): array
    {
        // If plain TextPart
        if ($part instanceof TextPart) {
            return [
                'contentType' => strtoupper($part->getMediaSubtype()) === 'PLAIN' ? 'Text' : 'HTML', // Handle both plain and html
                'content' => $part->bodyToString(),
            ];
        }

        // If multipart (alternative, related, mixed, etc.)
        if ($part instanceof MultipartPart) {
            foreach ($part->getParts() as $child) {
                $result = $this->extractBody($child);

                if (! empty($result['content'])) {
                    return $result;
                }
            }
        }

        return [
            'contentType' => 'Text',
            'content' => '',
        ];
    }

    protected function addresses(array $addresses): array
    {
        return collect($addresses)
            ->map(fn ($a) => [
                'emailAddress' => [
                    'address' => $a->getAddress(),
                ],
            ])
            ->values()
            ->all();
    }

    // protected function attachments(Email $email): array
    // {
    //     return collect($email->getAttachments())
    //         ->map(function (DataPart $part) {

    //             $body = $part->getBody();

    //             // Convert stream resources safely
    //             if (is_resource($body)) {
    //                 $body = stream_get_contents($body);
    //             }

    //             return [
    //                 '@odata.type' => '#microsoft.graph.fileAttachment',
    //                 'name' => $part->getFilename(),
    //                 'contentBytes' => base64_encode($body ?: ''),
    //                 'contentType' => $part->getMediaType() . '/' . $part->getMediaSubtype(),
    //                 'isInline' => $part->isInline(),
    //                 'contentId' => $part->getContentId(),
    //             ];
    //         })
    //         ->values()
    //         ->all();
    // }

    protected function attachments(Email $email): array
    {
        return collect($email->getAttachments())
            ->map(function (DataPart $part) {

                return [
                    '@odata.type' => '#microsoft.graph.fileAttachment',
                    'name' => $part->getFilename(),
                    'contentBytes' => base64_encode($part->bodyToString()),
                    'contentType' => $part->getMediaType() . '/' . $part->getMediaSubtype(),
                    'isInline' => $part->getDisposition() === 'inline',
                    'contentId' => $part->getContentId(),
                ];
            })
            ->values()
            ->all();
    }


    protected function headers(Email $email): array
    {
        $messageId = $email->getHeaders()->get('Message-ID');

        if (! $messageId) {
            return [];
        }

        return [
            [
                'name' => 'Message-ID',
                'value' => $messageId->getBody(),
            ],
        ];
    }
}
