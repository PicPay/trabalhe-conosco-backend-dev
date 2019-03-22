package com.example.es.jobs;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.net.URL;
import java.nio.channels.Channels;
import java.nio.channels.ReadableByteChannel;
import java.util.zip.GZIPInputStream;

import org.springframework.batch.core.ExitStatus;
import org.springframework.batch.core.StepContribution;
import org.springframework.batch.core.StepExecution;
import org.springframework.batch.core.StepExecutionListener;
import org.springframework.batch.core.scope.context.ChunkContext;
import org.springframework.batch.core.step.tasklet.Tasklet;
import org.springframework.batch.repeat.RepeatStatus;




class Downloader implements Tasklet, StepExecutionListener {

    String filePath;
    String downloadUrl;

    public Downloader(String filePath, String downloadUrl){
        this.filePath=filePath;
        this.downloadUrl=downloadUrl;
    }

    @Override
    public void beforeStep(StepExecution stepExecution) {

    }

    @Override
    public ExitStatus afterStep(StepExecution stepExecution) {
        return null;
    }

    @Override
    public RepeatStatus execute(StepContribution contribution, ChunkContext chunkContext) throws Exception {
       
        File file;

        file = new File(filePath);

        if (!file.exists()) {
            file.createNewFile();
        }

        URL url = new URL(downloadUrl);
        ReadableByteChannel readableByteChannel = Channels.newChannel(url.openStream());

        FileOutputStream fileOutputStream = new FileOutputStream(file);

        fileOutputStream.getChannel().transferFrom(readableByteChannel, 0, Long.MAX_VALUE);
        fileOutputStream.close();

        try{
            unGzip(file,true);
        }catch(Exception e){
            throw e;
        }
        

        return RepeatStatus.FINISHED;
    }

    public static File unGzip(File infile, boolean deleteGzipfileOnSuccess) throws IOException {
        GZIPInputStream gin = new GZIPInputStream(new FileInputStream(infile));
        FileOutputStream fos = null;
        try {
            File outFile = new File(infile.getParent(), infile.getName().replaceAll("\\.gz$", ""));
            fos = new FileOutputStream(outFile);
            byte[] buf = new byte[100000];
            int len;
            while ((len = gin.read(buf)) > 0) {
                fos.write(buf, 0, len);
            }
    
            fos.close();            
            return outFile; 
        } finally {           

            if (gin != null) {
                gin.close();    
            }
            if (fos != null) {
                fos.close();    
            }

            if (deleteGzipfileOnSuccess) {
                System.out.println("Deleta gzip");
                infile.delete();
            }
        }       
    }

}