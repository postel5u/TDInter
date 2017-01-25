<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

  <xsl:strip-space elements="previsions"/>
    <xsl:output
      method = "html"
      encoding = "UTF-8"
      indent = "yes"
       />
       <xsl:template match="/previsions">
         <html>
           <head></head>
           <body>
             <h1>Meteo a Nancy</h1>

             <p><xsl:apply-templates select="echeance"/></p>

           </body>
         </html>
       </xsl:template>
       <xsl:template match="echeance">
         <h3>Le <xsl:value-of select="substring(@timestamp, 9,2)"/>/<xsl:value-of select="substring(@timestamp, 6,2)"/>/<xsl:value-of select="substring(@timestamp, 1,4)"/></h3>
         <xsl:apply-templates select="temperature/level"/>
       </xsl:template>

       <xsl:template match="temperature/level">
         <xsl:if test="@val = 'sol'">
           <p>Temperature : <xsl:value-of select="round((. -273.15)* 100) div 100"/>°C</p>
         </xsl:if>
       </xsl:template>


</xsl:stylesheet>
