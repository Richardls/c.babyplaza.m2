<?php
namespace Ecommerce360\ScrapyIntegration\Api;

interface LinkRepositoryInterface
{
    /**
     * Return a filtered link.
     *
     * @param int $id
     * @return \Ecommerce360\ScrapyIntegration\Api\ResponseItemInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getItem(int $id);

    /**
     * Update link information.
     *
     * @param int $id
     * @param LinkUpdateDataInterface $data
     * @return bool
     */
    public function update(int $id, LinkUpdateDataInterface $data): bool;

    /**
     * Create a new link record
     *
     * @param LinkUpdateDataInterface $data
     * @return int The ID of the created link
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function create(LinkUpdateDataInterface $data): int;

}
