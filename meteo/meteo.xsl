<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

  <xsl:strip-space elements="previsions"/>
    <xsl:output
      method = "html"
      encoding = "UTF-8"
      indent = "yes"
       />

<xsl:template match="/">

  <html>

    <head>

    </head>

    <body>
        <xsl:apply-templates select="echeance"/>
    </body>

  </html>

</xsl:template>


<xsl:template match="echeance">

  <h2><xsl:value-of select="@timestamp"/></h2>

</xsl:template>

<xsl:template match="temperature">
    <p>Temperature au sol: <xsl:value-of select="sol"/></p>
</xsl:template>

<xsl:template match="text()">

</xsl:template>

</xsl:stylesheet>
