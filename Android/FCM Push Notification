```java
package amz.piz.admin;

import android.app.Notification;
import android.app.NotificationChannel;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Intent;
import android.media.AudioAttributes;
import android.media.MediaPlayer;
import android.media.RingtoneManager;
import android.net.Uri;
import android.os.Build;
import android.os.VibrationEffect;
import android.os.Vibrator;
import android.provider.Settings;
import android.util.Log;
import androidx.core.app.NotificationCompat;
import androidx.core.app.NotificationManagerCompat;
import com.google.firebase.messaging.FirebaseMessagingService;
import com.google.firebase.messaging.RemoteMessage;

public class NotifService extends FirebaseMessagingService {
    @Override
    public void onMessageReceived(RemoteMessage arg0) {
        super.onMessageReceived(arg0);
        // TODO: Implement this method
        if (arg0 != null) {
            startService(new Intent(this, SoundService.class));
            Log.w("fcm", "REceived");
            sendNotif(arg0.getNotification().getTitle(), arg0.getNotification().getBody());
        }
    }

    private void sendNotif(String notifTtl, String notifDes) {
        Intent intent = new Intent(this, MainActivity.class);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
        PendingIntent pend_intent =
       		 PendingIntent.getActivity(this, 0, intent, PendingIntent.FLAG_IMMUTABLE);
        
        NotificationCompat.Builder builder =
                new NotificationCompat.Builder(this, "def_id")
                        .setSmallIcon(R.mipmap.ic_launcher)
                        .setContentTitle(notifTtl)
                        .setContentText(notifDes)
                        .setPriority(NotificationCompat.PRIORITY_MAX)
                        .setContentIntent(pend_intent);
        
        NotificationManagerCompat notif_manager = NotificationManagerCompat.from(this);
        notif_manager.notify(1, builder.build());
    }


}
```
