<?xml version="1.0"?>
<schema xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:framework:Setup/Declaration/Schema/etc/schema.xsd">

    <table name="ecommerce360_masterlinks" resource="default" engine="innodb" comment="Master Links Table">
        <column xsi:type="int" name="entity_id" identity="true" unsigned="true" nullable="false" comment="Primary Key"/>
        <column xsi:type="varchar" name="sku_magento" nullable="true" length="64" comment="Magento SKU"/>
        <column xsi:type="varchar" name="sku_store" nullable="true" length="255" comment="Store SKU"/>
        <column xsi:type="text" name="link_url" nullable="true" comment="Product Link URL"/>
        <column xsi:type="decimal" name="min_price" nullable="true" scale="2" precision="12" comment="Minimum Price"/>
        <column xsi:type="decimal" name="list_price" nullable="true" scale="2" precision="12" comment="List Price"/>
        <column xsi:type="varchar" name="store_domain" nullable="true" length="255" comment="Store Domain"/>
        <column xsi:type="varchar" name="store_productname" nullable="true" length="255" comment="Store Product Name"/>
        <column xsi:type="varchar" name="store_brand" nullable="true" length="255" comment="Store Brand"/>
        <column xsi:type="smallint" name="availability" nullable="true" default="0" comment="Availability / In Stock"/>
        <column xsi:type="text" name="image_url" nullable="true" comment="Image URL"/>
        <column xsi:type="timestamp" name="created_at" nullable="true" default="CURRENT_TIMESTAMP" comment="Created At"/>

        <!-- Campos para indicar si ya se usó este link -->
        <column xsi:type="smallint" name="used_in_product_links" nullable="false" default="0" comment="Used in Product Links?"/>
        <column xsi:type="smallint" name="used_in_price_history" nullable="false" default="0" comment="Used in Price History?"/>

        <constraint xsi:type="primary" referenceId="PRIMARY">
            <column name="entity_id"/>
        </constraint>
    </table>

</schema>
