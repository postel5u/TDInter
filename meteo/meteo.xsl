<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

  <xsl:strip-space elements="previsions"/>
    <xsl:output
      method = "html"
      encoding = "UTF-8"
      indent = "yes"
       />
       <xsl:template match="/previsions">
         <html>
           <head>
             <link href="meteo.css" rel="stylesheet"/>
           </head>
           <body>
             <h1>Meteo a Nancy</h1>

             <div>
               <xsl:apply-templates select="echeance"/>
             </div>

           </body>
         </html>
       </xsl:template>
       <xsl:template match="echeance">
         <xsl:if test="substring(@timestamp, 12,2) = '13'">
           <div>
             <h3>
               Le <xsl:value-of select="substring(@timestamp, 9,2)"/>/<xsl:value-of select="substring(@timestamp, 6,2)"/>/<xsl:value-of select="substring(@timestamp, 1,4)"/> à <xsl:value-of select="substring(@timestamp, 12,2)"/>h
             </h3>
             <xsl:apply-templates select="temperature/level"/>
           </div>
         </xsl:if>
       </xsl:template>

       <xsl:template match="temperature/level">
         <xsl:if test="@val = 'sol'">
           <p>
             Temperature : <xsl:value-of select="round((. -273.15))"/>°C
           </p>
         </xsl:if>
       </xsl:template>


</xsl:stylesheet>
